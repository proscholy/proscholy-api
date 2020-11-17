import gql from 'graphql-tag';

const fragment = gql`
    fragment TagFillableFragment on Tag {
        id
        name
        description
        hide_in_liturgy
    }
`;

const QUERY = gql`
    query($id: ID!) {
        model_database: tag(id: $id) {
            ...TagFillableFragment
            type_enum   
            is_for_songs
        }
    }
    ${fragment}
`;

const MUTATION = gql`
    mutation(
        $input: UpdateTagInput!
    ) {
        update_tag(input: $input) {
            ...TagFillableFragment
        }
    }
    ${fragment}
`;

export default {
    fragment,
    QUERY,
    MUTATION,

    getQueryVariables: vueModel => ({
        id: vueModel.id
    }),

    getMutationVariables: vueModel => ({
        input: {
            ...vueModel
        }
    })
};
