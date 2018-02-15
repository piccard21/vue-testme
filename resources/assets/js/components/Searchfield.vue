<template>
	<el-input
			v-model="searchVal"
			@change="filterDomain"
			clearable>
		<template slot="prepend">Filter</template>
	</el-input>
</template>



<script>
	export default {
		data() {
			return { 
				searchVal: ''
			}
		},
		methods: {
			filterDomain(text) {
				this.$store.commit('setSearchText', text);
				// console.info(this.$store.getters.searchText);
			}
		} 
	}
</script>

<style>
</style>