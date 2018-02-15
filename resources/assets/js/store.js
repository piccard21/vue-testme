import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        tlds: ['com', 'biz', 'info'],
        searchText: 'whatever',
        domains: internetx.domainList
    },
    getters: {
        tlds(state) {
            return state.tlds;
        },
        searchText(state) {
            return state.searchText;
        },
        domainList(state) {
            return state.domains;
        }
    },
    mutations: {
    	setSearchText(state, text) {
    		state.searchText = text;
    	},
    	setTlds(state, tlds) {
    		state.tlds = tlds;
    	},
    	setDomains(state, domains) {
    		state.domains = domains;
    	}
    },
    actions: {
	    domains (context, domains) {
            $.busyLoadFull("show"); 
            axios({
                method: 'post',
                url: laroute.route('customer.filter'),
                data: {
                    tlds: this.state.tlds,
                    search: this.state.searchText
                }
            }).then((response) => { 
	      		context.commit('setDomains', response.data.data)
                $.busyLoadFull("hide");
            })
	    } 
    }
});