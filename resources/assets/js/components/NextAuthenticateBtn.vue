<template>
	<div class="text-center">
		<el-button type="primary" plain :disabled="disabled" @click="showDialog">{{ Lang.get('js.Next') }}</el-button>
	</div>
</template>

<script>
	import Lang from '../mixins/Lang';
	import IxEvent from '../mixins/IxEvent';

	export default {
		props: ['location', 'label'],
		data() {
			return {
				disabled: false
			}
		},
		mixins: [Lang, IxEvent],
		methods: {
			navigate() {
				window.location = this.location;
			},
			showDialog() {
				IxEvent.fire('show-login-dialog', true);
			}
		},
		mounted() {
			IxEvent.listen('domain-selection-changed', (hasSelection) => {
				this.disabled = !hasSelection;
			});
		}
	};
</script>