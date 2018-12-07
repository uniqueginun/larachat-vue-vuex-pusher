<template>
    <div class="col-md-4 col-xl-3 chat"><div class="card mb-sm-3 mb-md-0 contacts_card">
        <search @searchcontacts="searchcontacts"></search>
        <div class="card-body contacts_body">
            <ul class="contacts">
                <singlecontact :contact="contact" v-for="contact in contactslist" :key="contact.id"></singlecontact>
            </ul>
        </div>
        <div class="card-footer"></div>
    </div>
</div>
</template>

<script>
import search from './Search';
import singlecontact from './Single';

export default {
    computed: {
        contactslist() {
            return this.$store.getters.contacts;
        }
    },
    components: {
        search, singlecontact
    },
    methods: {
       searchcontacts(keyword) {
           this.$store.commit('filtercontacts', keyword);
       }
    }
}
</script>

<style>

</style>
