export default {
	methods: {
		handleResult: function (response) {
			const type = (_.get(response, 'data.success')) ? 'success' : 'error'

			this.$message({
				message: _.get(response, 'data.msg', ''),
				type: type
			});
		}
	}
}