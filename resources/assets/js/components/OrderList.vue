<template>
	<el-table :data="tableData">

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
		<el-table-column label="Price">
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
						size="mini"
						type="danger"
						@click="handleDelete(scope.$index, scope.row, scope.row.id)">{{ Lang.get('js.Delete') }}
				</el-button>
			</template>
		</el-table-column>


	</el-table>
</template>

<script>
	import HandleResult from '../mixins/HandleResult';
	import LaRoute from '../mixins/LaRoute';
	import IxEvent from '../mixins/IxEvent';
	import Lang from '../mixins/Lang';

	export default {
		mixins: [HandleResult, LaRoute, IxEvent, Lang],
		data() {
			return {
				tableData: internetx.domainsSelected
			}
		},
		methods: {
			hasSelection() {
				let hasSelection = false;
				this.tableData.forEach((value) => {
					if (value.status === 'selected') {
						hasSelection = true;
					}
				});

				return hasSelection;
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

						this.tableData.splice(index, 1);

						$.busyLoadFull("hide");
						row.status = 'open';
						this.handleResult(response);

						IxEvent.fire('domain-selection-changed', this.hasSelection());
					}
				)
			}
		},
		mounted() {
			IxEvent.fire('domain-selection-changed', this.hasSelection());
		}

	}
</script>


<style>
	.el-table .success-row {
		background: #f0f9eb;
	}
</style>