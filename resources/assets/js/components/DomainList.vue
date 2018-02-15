<template>
	<div class="wrap" style="height: 200px; overflow: auto;" ref="wrap">
		<el-table
				:data="tableData"
				:row-class-name="tableRowClassName">

			<!--domain-name-->
			<el-table-column
					label="Name"
					width="180">
				<template slot-scope="scope">
					<div slot="reference" class="name-wrapper">
						<el-tag size="medium">{{ scope.row.name }}</el-tag>
					</div>
				</template>
			</el-table-column>

			<!--price-->
			<el-table-column
					label="Price">
				<template slot-scope="scope">
					<span style="margin-left: 10px">{{ scope.row.price }}</span>
					<i class="fa fa-eur"></i>
				</template>
			</el-table-column>


			<!--actions -->
			<el-table-column label="Operations"
			                 fixed="right"
			                 width="180">
				<template slot-scope="scope">
					<el-button
							v-show="scope.row.status==='open'"
							size="mini"
							@click="handleAdd(scope.$index, scope.row, scope.row.id)">{{ Lang.get('js.Select') }}
					</el-button>
					<el-button
							v-show="scope.row.status==='selected'"
							size="mini"
							type="danger"
							@click="handleDelete(scope.$index, scope.row, scope.row.id)">{{ Lang.get('js.Delete') }}
					</el-button>
				</template>
			</el-table-column>
		</el-table>

		<!--endless-scroll-->
		<mugen-scroll
				:handler="fetchData"
				:should-handle="!loading"
				scroll-container="wrap"
				class="mugen-height">
		</mugen-scroll>
	</div>

</template>

<script>
	import HandleResult from '../mixins/HandleResult';
	import LaRoute from '../mixins/LaRoute';
	import Lang from '../mixins/Lang';
	import IxEvent from '../mixins/IxEvent';
	import MugenScroll from 'vue-mugen-scroll'

	export default {
		components: {
			MugenScroll
		},
		mixins: [HandleResult, LaRoute, Lang, IxEvent],
		data() {
			return {
				tableData: internetx.domainList,
				loading: false
			}
		},
		mounted() {
			this.hasSelection();
		},
		methods: {
			hasSelection() {
				let hasSelection = false;
				this.tableData.forEach((value) => {
					if (value.status === 'selected') {
						hasSelection = true;
					}
				});
				IxEvent.fire('domain-selection-changed', hasSelection);
			},
			handleAdd(index, row, domainId) {
				$.busyLoadFull("show");
				axios({
					method: 'post',
					url: laroute.route('order.domain.add'),
					data: {
						'domainId': domainId
					}
				}).then((response) => {
						$.busyLoadFull("hide");
						row.status = 'selected';
						this.handleResult(response);
						this.hasSelection();
					}
				)
			},
			handleDelete(index, row, domainId) {
				$.busyLoadFull("show");
				axios({
					method: 'post',
					url: laroute.route('order.domain.remove'),
					data: {
						'domainId': domainId
					}
				}).then((response) => {
						$.busyLoadFull("hide");
						row.status = 'open';
						this.handleResult(response);
						this.hasSelection();
					}
				)
			},
			tableRowClassName({row, rowIndex}) {
				if (row.status === 'selected') {
					return 'success-row';
				}
				return '';
			},
			fetchData() {
				this.loading = true
				$(".mugen-height ").busyLoad("show");
				setTimeout(() => {
					this.loading = false
					$(".mugen-height ").busyLoad("hide");
				}, 500)
			}
		}
	}
</script>


<style>
	.el-table .success-row {
		background: #f0f9eb;
	}

	.mugen-height {
		height: 3rem;
	}
</style>