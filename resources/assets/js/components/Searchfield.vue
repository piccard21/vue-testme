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
			filterDomain(val) {
				console.info(val);
			}
		}
	}
</script>

<style>
</style>