<template>
	<div>
		{{checkedTlds}}
		<el-collapse v-model="activeName" @change="handleChange" accordion>
			<el-collapse-item title="Tlds" name="1">

				<el-checkbox :indeterminate="isIndeterminate" v-model="checkAll" @change="handleCheckAllChange">
					Check all
				</el-checkbox>

				<div style="margin: 1rem 0;"></div>

				<!--<el-checkbox-group v-model="checkedTlds" @change="handleCheckedTldsChange">-->
					<!--<el-checkbox v-for="tld in tlds" :label="tld" :key="tld">{{ tld }}</el-checkbox>-->
				<!--</el-checkbox-group>-->


				<div style="margin-top: 20px">
					<el-checkbox-group v-model="checkedTlds"  @change="handleCheckedTldsChange" size="small">
						<el-checkbox-button v-for="tld in tlds" :label="tld" :key="tld">{{tld}}</el-checkbox-button>
					</el-checkbox-group>
				</div>

			</el-collapse-item>
		</el-collapse>
	</div>
</template>

<script>

	import HandleResult from '../mixins/HandleResult';
	import GetDomainList from '../mixins/GetDomainList';
	import LaRoute from '../mixins/LaRoute';
	import IxEvent from '../mixins/IxEvent';

	export default {
		mixins: [HandleResult, LaRoute, IxEvent],
		data() {
			return {
				checkAll: true,
				checkedTlds: [],
				tlds: [],
				isIndeterminate: true,
				activeName: ''
			};
		},
		methods: {
			queryDomains: _.debounce((cb, tlds=[]) => {
				cb(tlds);
			}, 1000),
			handleCheckAllChange(val) {
				this.checkedTlds = val ? this.tldOptions : [];
				this.isIndeterminate = false;
				this.queryDomains(this.getDomainList, this.checkedTlds);
			},
			handleCheckedTldsChange(value) {
				let checkedCount = value.length;
				this.checkAll = checkedCount === this.tlds.length;
				this.isIndeterminate = checkedCount > 0 && checkedCount < this.tlds.length;
				this.queryDomains(this.getDomainList, this.checkedTlds);
			},
			handleChange(val) {},
			getDomainList(tlds) {
				$.busyLoadFull("show");
				axios({
					method: 'post',
					url: laroute.route('customer.filter'),
					data: {
						tlds: tlds
					}
				}).then((response) => { 
					console.info(response.data); 
					$.busyLoadFull("hide"); 
					IxEvent.fire('domain-list-changed', response.data.data);
					}
				)
			}
		},
		computed: {
			tldOptions() {
				return window.internetx.tldOptions;
			}
		},
		mounted() {
			this.tlds = window.internetx.tldOptions;
			this.checkedTlds = window.internetx.tldOptions;
		}
	};
</script>


<style>
</style>