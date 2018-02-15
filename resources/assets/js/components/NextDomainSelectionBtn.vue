<template>
	<div class="text-center">
		<!--<a class="btn btn-primary" :class="{disabled: disabled}" :href="laroute.route('order.index')">{{ Lang.get('js.Next') }}</a>-->
		<!--<el-button type="primary" :disabled="disabled" plain @click="navigate">{{ Lang.get('js.Next') }}</el-button>-->
		<el-button type="primary" :disabled="disabled" plain @click="navigate">{{ label }}</el-button>
	</div>
</template>

<script>
	import Lang from '../mixins/Lang';
	import IxEvent from '../mixins/IxEvent';

	export default {
		props: ['location', 'label'],
		data() {
			return {
				disabled: true
			}
		},
		mixins: [Lang, IxEvent],
		methods: {
			navigate() {
				window.location = this.location;
			}
		},
		
		mounted() {
			IxEvent.listen('domain-selection-changed', (hasSelection) => {
				this.disabled = !hasSelection;
			});
		}
	};
</script>