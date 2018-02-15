// let listeners = {};
//
// export default {
// 	methods: {
// 		$_globalEvent_fire(id, data) {
// 			listeners[id].forEach(cb => {
// 				cb(data);
// 			});
// 		},
// 		$_globalEvent_listen(id, cb) {
// 			listeners[id].push(cb);
// 		}
// 	}
// };


/** simple component-communication**/
const localVue = new Vue();
let dataBuffer = {};
export default {
	fire(event, data = null) {
		if (data !== null) {
			dataBuffer[event] = data;
		}
		localVue.$emit(event, data);
	},

	listen(event, callback) {
		localVue.$on(event, callback);
		if (event in dataBuffer) {
			callback(dataBuffer[event]);
		}
	}
}