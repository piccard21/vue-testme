
// import HandleResult from '../mixins/HandleResult';

// export default {
// 	mixins: [HandleResult],
// 	methods: {
// 		getDomainList(tlds) {
// 			$.busyLoadFull("show");
// 			axios({
// 				method: 'post',
// 				url: laroute.route('customer.filter'),
// 				data: {
// 					tlds: tlds
// 				}
// 			}).then((response) => { 
// 				console.info(response.data);
// 				$.busyLoadFull("hide");
// 				// this.handleResult(response);
// 				}
// 			)
// 		}
// 	}
// }