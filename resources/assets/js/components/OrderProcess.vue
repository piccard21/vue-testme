<template>
	<ul class="list-group">
		<li class="list-group-item d-flex justify-content-between align-items-center" :class="{
			'list-group-item-success': ['success'].includes(domain.status),
			'list-group-item-warning': ['running'].includes(domain.status),
			'list-group-item-danger': ['error'].includes(domain.status)
		}" v-for="(domain, index) in domains" :key="domain.id">
			{{domain.name}}
			<span class="badge badge-pill"><i class="fa" :class="{
			'fa-spinner fa-spin': ['pending'].includes(domain.status),
			'fa-refresh fa-spin': ['running'].includes(domain.status),
			'fa-check': ['success'].includes(domain.status),
			'fa-exclamation': ['error'].includes(domain.status),
			}"></i></span>
		</li>
	</ul>
</template>

<script>
	import HandleResult from '../mixins/HandleResult';
	import LaRoute from '../mixins/LaRoute';
	import IxEvent from '../mixins/IxEvent';

	export default {
		mixins: [HandleResult, LaRoute, IxEvent],
		data() {
			return {
				domains: internetx.pendingDomains,
				interval: false
			}
		},
		methods: {
			checkStatus() {
				axios({
					method: 'get',
					url: laroute.route('order.domain.check'),
				}).then((response) => {
						response.data.forEach((responseDomain) => {
							let existingDomain = this.domains.find(x => x.id == responseDomain.id);
							if (existingDomain) {
								Object.assign(existingDomain, responseDomain);
							} else {
								this.domains.push(responseDomain);
							}
							this.checkComplete();
						});
					}
				)
			},
			checkComplete() {
				let domainsRunning = this.domains.filter((domain) => {
					return domain.status != 'success' && domain.status != 'error';
				});
				if (!domainsRunning.length) {
					clearInterval(this.interval);
					IxEvent.fire('ix-order-finished', true);
				}
			}
		},
		mounted() {
			this.interval = setInterval(() => {
				this.checkStatus();
			}, 2000);
		}

	}
</script>


<style>
</style>