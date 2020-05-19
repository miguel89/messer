<template>
    <div class="modal fade" v-bind:id="'deleteModal' + messageId" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Confirm deleting the message? You won't be able to undo this action.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" v-on:click="deleteMessage()">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ConfirmDeleteComponent",
        props: ['messageId'],
        methods: {
            deleteMessage() {
                this.$http.delete(`/messages/${this.messageId}`)
                    .then(resp => {
                        $(`#deleteModal${this.messageId}`).modal('hide');
                        this.$emit('deleted');
                    }).catch(err => (console.error(err)));
            }
        }
    }
</script>

<style scoped>

</style>
