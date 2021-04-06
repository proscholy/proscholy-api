<?php

namespace App\Services;

use ProScholy\LilypondRenderer\Client;
use ProScholy\LilypondRenderer\LilypondBasicTemplate;
use ProScholy\LilypondRenderer\LilypondPartsTemplate;

use Illuminate\Support\Str;
use ProScholy\LilypondRenderer\LilypondPartsGlobalConfig;

class LilypondService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    private function doClientRenderSvg($src, $crop)
    {
        $res = $this->client->renderSvg($src, $crop);

        if ($res->isSuccessful()) {
            $output = $this->client->getResultOutputFile($res);
        } else {
            $output = $this->client->getResultLog($res);
        }

        $this->client->deleteResultAsync($res);

        return $output;
    }

    public function makePartSvgFast($part, $global_src, $global_config_input)
    {
        return $this->doClientRenderSvg($this->makeLilypondPartsTemplate([$part], $global_src, $global_config_input), false);
    }

    public function makeTotalSvgFast($parts, $global_src, $global_config_input)
    {
        return $this->doClientRenderSvg($this->makeLilypondPartsTemplate($parts, $global_src, $global_config_input), false);
    }

    public function makeSvgFast($lilypond, $key_major = null)
    {
        return $this->doClientRenderSvg($this->makeLilypondBasicTemplate($lilypond, $key_major), false);
    }

    public function makeSvg($lilypond, $key_major = null)
    {
        return $this->doClientRenderSvg($this->makeLilypondBasicTemplate($lilypond, $key_major), true);
    }

    public function makeLilypondBasicTemplate($lilypond, $key_major = null): LilypondBasicTemplate
    {
        $src = new LilypondBasicTemplate($lilypond);
        $src->applyDefaultLayout('amiri', 2.5, 'amiri', 3)->applyInfinitePaper()->applyTinynotes();

        if ($key_major) {
            $src->setOriginalKey($key_major);
        }

        return $src;
    }

    public function makeLilypondPartsTemplate($parts, $global_src, $global_config_input = []): LilypondPartsTemplate
    {
        $global_config_input_with_defaults = array_merge(
            $this->getDefaultGlobalConfigData(true),
            $global_config_input
        );

        $global_config = new LilypondPartsGlobalConfig(
            $global_config_input_with_defaults['version'],
            $global_config_input_with_defaults['two_voices_per_staff'],
            $global_config_input_with_defaults['global_transpose_relative_c'],
            $global_config_input_with_defaults['merge_rests'],
            $global_config_input_with_defaults['hide_bar_numbers'],
            $global_config_input_with_defaults['force_part_breaks']
        );

        if (count($global_config_input_with_defaults['hide_voices']) > 0) {
            $global_config->setVoicesHidden($global_config_input_with_defaults['hide_voices']);
        }

        if (isset($global_config_input_with_defaults['paper_width_mm'])) {
            $global_config->setCustomPaper($global_config_input_with_defaults['paper_width_mm']);
        }

        $src = new LilypondPartsTemplate($global_src, $global_config);

        foreach ($parts as $part) {
            $key_major = $part['key_major'] ?? 'c';
            $time_signature = $part['time_signature'] ?? '4/4';

            $src->withPart(
                $part['name'],
                $part['src'] ?? '',
                $key_major,
                $part['end_key_major'] ?? $key_major,
                $time_signature,
                $part['end_time_signature'] ?? $time_signature,
                $part['break_before'] ?? false
            );
        }

        return $src;
    }

    public function getDefaultGlobalConfigData(bool $include_onetime)
    {
        $arr = [
            'version' => '2.22.0',
            'two_voices_per_staff' => true,
            'merge_rests' => true
        ];

        if ($include_onetime) {
            $arr = array_merge($arr, [
                'global_transpose_relative_c' => false,
                'hide_bar_numbers' => true,
                'force_part_breaks' => false,
                'hide_voices' => []
            ]);
        }

        return $arr;
    }

    public function needsLilypondUpdate($lilypond): bool
    {
        $lp_no_spaces = str_replace(' ', '', $lilypond);

        if (!Str::contains($lp_no_spaces, 'melodie=')) {
            return true;
        }

        if (Str::contains($lp_no_spaces, 'indent=0') || Str::contains($lp_no_spaces, 'tagline=""')) {
            return true;
        }

        return false;
    }
}
