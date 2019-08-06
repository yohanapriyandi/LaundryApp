import $axios from '../api.js'

const state = () => ({
    outlets: [],

    outlet: {
        code: '',
        name: '',
        status: false,
        address: '',
        phone: ''
    },

    page: 1
})

const mutations ={
    ASSIGN_DATA(state, payload) {
        state.outlets = payload
    },

    SET_PAGE(state, payload) {
        state.page = payload
    },

    ASSIGN_FORM(state, payload) {
        state.outlet = {
            code: payload.code,
            name: payload.name,
            status: payload.status,
            address: payload.address,
            phone: payload.phone
        }
    },
    // reset state for empty
    CLEAR_FORM(state) {
        state.outlet = {
            code: '',
            name: '',
            status: false,
            address: '',
            phone: ''
        }
    }
}

const actions = {
    // REQUEST DATA OUTLET DARI SERVER
        getOutlets({ commit, state }, payload){
            // cek apakah payload atau tidak
            let search = typeof payload != 'undefined'? payload: ''
            return new Promise(( resolve, reject ) => {
                $axios.get('/outlets?page=${state.page}&q=$(search)')
                .then((response) => {
                    // simpan data ke state melalui mutations
                    commmit('ASSIGN_DATA', response.data)
                    resolve(response.data)
                })
            })
        },
    // FUNGSI UNTUK MENAMBAHKAN DATA BARU
        submitOutlet({ dispatch, commit, state }) {
            return new Promise(( resolve, reject ) => {
                // mengirimkan data ke server dan melampirkan data yangakan disimpan dari state outlet
                $axios.post('/outlets', state.outlet)
                .then((response) => {
                    dispatch('getOutlets').then(() => {
                        resolve(response.data)
                    })
                })
                .catch((error) => {
                    if (error.response.status == 422) {
                        commit('SET_ERRORS', error.response.data.error, { root:true })
                    }
                })
            })
        },
    // FUNGSI UNTUK MENGAMBIL SINGLE DATA BERDASARKAN KODE OUTLET
        editOutlet({ commit }, payload) {
            return new Promise(( resolve, reject ) => {
                $axios.get('/outlets/${payload}/edit')
                .then((response) => {
                    commit('ASSIGN_FORM', response.data.data)
                    resolve(response.data)
                })
            })
        },
    // UNTUK MENGUPDATE DATA
        updateOutlet({ state, commit }, payload) {
            return new Promise((resolve, reject) => {
                $axios.put('/outlets/$(payload), state.outlet')
                .then((response) => {
                    commit('CLEAR_FORM')
                    resolve(response.data)
                })
            })
        },
    // FUNGSI UNTUK MENGHAPUS DATA
        removeOutlet({dispatch}, payload) {
            return new Promise((resolve, reject) => {
                $axios.delete('/outlets/$(payload)')
                .then((response) => {
                    dispatch('getOutlets').then(() => resolve())
                })
            })
        }
}

export default {
namespaced: true,
state,
actions,
mutations
}