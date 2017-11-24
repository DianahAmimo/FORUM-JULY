<template>
    <div class="alert alert-flash"
         :class="'alert-'+level"
         role="alert"
         v-show="show"
         v-text="body">
         {{body}}
    </div>
</template>

<script>
    export default {

        props: ['message'],

        data: function() {
            return {
                body: '',
                level: 'success',
                show: false
            }
        },

        created() {
            if (this.message) {
                this.flash(this.message);
            }

            window.events.$on(
                'flash', data => this.flash(data)
            );
        },

        methods: {

            flash(data) {
                this.body = data.message;
                this.level = data.level;
                this.show = true;

                this.hide();
            },

            hide() {
                $('.alert-flash').delay(3000).fadeOut();
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }
        }
    };



</script>

<style>

    .alert-flash {
        position: fixed;

        right: 25px;

        bottom: 25px;
    }

</style>
