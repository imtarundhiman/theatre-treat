export default {
    methods: {
    	processGetRequest(url = '', params = {}, headers = {}){
    		return axios.get(url, {
				params: params,
				headers: headers
			})
    	},
        processPostRequest(url = '', params = null, headers = {}, uploadProgressMethod = null ){
	        return axios.post(url , params, {
				headers: headers,
				onUploadProgress: uploadProgressMethod
			})
		},
		processDeleteRequest(url = '', params = {}){
	        return axios.delete(url , params)
    	}
    },
}