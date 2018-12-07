<template>
    <div class="card-header">
        <div class="input-group">
            <input type="text" v-model="keyword" @keyup="filter" placeholder="Search..." name="" class="form-control search">
            <div class="input-group-prepend">
                <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            keyword: ''
        }
    },
    methods: {
        filter() {
            this.$emit('searchcontacts', this.keyword);
        }
    }
}
</script>

<style>

</style>
