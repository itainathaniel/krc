<template>
    <div :class="getMemberClassname()"
        :style="{ backgroundImage: 'url(' + image + ')' }">
        <a :href="href">
            <h4>{{ name }}</h4>
        </a>
    </div>
</template>

<script>
    export default {
        props: {
            name: { required: true },
            image: { required: true },
            href: { required: true },
            present: { required: true }
        },

        methods: {
            isPresent() {
                return this.present == 1;
            },

            getMemberClassname() {
                let base = this.baseClassname + ' is-' + (!this.isPresent() ? 'not-' : '') + 'present';

                if (this.name.length >= this.longname) {
                    return base + ' member__profile__long-name';
                }

                return base;
            }
        },

        data() {
            return {
                baseClassname: 'column member__profile',
                longname: 15
            }
        },

        mounted() {
            console.log('Member component ready.')
        }
    }
</script>
