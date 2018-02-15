<template>
	<div class="text-center">
		<el-button type="primary" plain @click="navigate">{{ label }}</el-button>
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
		}
	};
</script>