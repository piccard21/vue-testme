<template>
	<div class="">
		<!--order-btn-->
		<!--<a class="btn btn-primary" style="color: #fff;" @click="dialogVisible=true" :class="{disabled: disabled}" >{{ Lang.get('js.Next') }}</a>-->
		<!--<el-button type="primary" plain :disabled="disabled" @click="dialogVisible=true">{{ Lang.get('js.Next') }}</el-button>-->

		<!--dialog-->
		<el-dialog
				title="Login"
				:visible.sync="dialogVisible"
				width="30%">
			<el-input
					type="password"
					placeholder="enter your password"
					suffix-icon="fas fa-unlock-alt"
					v-model="pwd"
					@keyup.enter.native="login">
			</el-input>

			<span slot="footer" class="dialog-footer">
			    <el-button @click="cancel">{{ Lang.get('js.Cancel') }}</el-button>
			    <el-button type="primary" @click="login">{{ Lang.get('js.Send') }}</el-button>
			</span>
		</el-dialog>
	</div>
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
				dialogVisible: false,
				// TODO
				pwd: 'Startrek,21',
				disabled: false
			};
		},
		methods: {
			cancel() {
				this.dialogVisible = false;
			},

			login() {
				this.dialogVisible = false;

				$.busyLoadFull("show");
				axios({
					method: 'post',
					url: laroute.route('order.domain.login'),
					data: {
						'pwd': this.pwd
					}
				}).then((response) => {
						$.busyLoadFull("hide");
						if (_.get(response, 'data.success')) {
							window.location = laroute.route('order.domain.order');
						} else {
							this.handleResult(response);
						}
					}
				)

			}
		},
		mounted() {
			IxEvent.listen('show-login-dialog', (isVisible) => {
				this.dialogVisible=isVisible;
			});
		}
	};
</script>