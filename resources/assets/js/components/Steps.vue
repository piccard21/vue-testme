<template>
	<div>
		<el-steps :active="activestep" :finish-status="isFinished">
			<el-step title="Step 1" description="Overview"></el-step>
			<el-step title="Step 2" description="Verification"></el-step>
			<el-step title="Step 3" description="Order"></el-step>
			<el-step title="Step 4" description="Finish"></el-step>
		</el-steps>
	</div>
</template>

<script>
	import IxEvent from '../mixins/IxEvent';

	export default {
		mixins: [IxEvent],
		props: {
			activestep: {
				type: Number,
				required: true,
				default: 1
			},
			finished: {
				type: String,
				default: 'process'
			}
		},
		data() {
			return {
				finishClass: undefined
			};
		},
		computed: {
			isFinished: function () {
				if(typeof this.finished === 'undefined') {
					return this.finished;
				} else {
					return this.finishClass;
				}
			}
		},
		mounted() {
			IxEvent.listen('ix-order-finished', (isFinished) => {
				if(isFinished) {
					this.finishClass = 'success';
					this.activestep = 4;
				}
			});
		}
	};
</script>

<style>
	.el-steps {
		margin: 3rem 0;
	}
</style>