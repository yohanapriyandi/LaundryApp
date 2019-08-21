import $axios from '../api.js'

const state = () => ({
    users: [],
    roles:[],
    permission:[],
    role_permission:[],
    authenticated: []
})

const mutations = {
    ASSIGN_USER (state, payload) {
        state.users = payload
    },
    ASSIGN_ROLES (state, payload) {
        state.roles = payload
    },
    ASSIGN_PERMISSION (state, payload) {
        state.permission = payload
    },
    ASSIGN_ROLE_PERMISSION (state, payload) {
        state.role_permission = payload
    },
    CLEAR_ROLE_PERMISSION (state, payload) {
        state.role_permission = payload
    },
    ASSIGN_USER_AUTH (state, payload) {
        state.authenticated = payload
    }
}

const actions = {
    getUserLists({commit}) {
        return new Promise((resolve, reject) => {
            $axios.get(`/user-lists`)
            .then((response) => {
                commit('ASSIGN_USER', response.data.data)
                resolve(response.data)
            })
        })
    },
    setRoleUser({commit}, payload) {
        return new Promise((resolve, reject) => {
            commit('CLEAR_ERRORS', '', {root: true})
            $axios.post(`/set-role-user`, payload)
            .then((response) => {
                resolve(response.data)
            })
            .catch((error) => {
                if (error.response.data == 422) {
                    commit('SET_ERRORS', errors.response.data.errors, {root: true})
                }
            })
        })
    },
    getRoles({commit}) {
        return new Promise((resolve, reject) => {
            $axios.get(`/roles`)
            .then((response) => {
                commit('ASSIGN_ROLES', response.data.data)
                resolve(response.data)
            })
        })
    },
    getAllPermission({commit}) {
        return new Promise((resolve, reject) => {
            $axios.get(`/permissions`)
            .then((response) => {
                commit('ASSIGN_PERMISSION', response.data.data)
                resolve(response.data)
            })
        })
    },
    getRolePermission({commit}, payload) {
        return new Promise((resolve, reject) => {
            commit('CLEAR_ERRORS', '', {root: true})
            $axios.post(`/role-permission`, {role_id: payload})
            .then((response) => {
                commit('ASSIGN_ROLE_PERMISSION', response.data.data)
                resolve(response.data)
            })
        })
    },
    setRolePermission({commit}, payload) {
        return new Promise((resolve, reject) => {
            commit('CLEAR_ERRORS', '', {root:true})
            $axios.post(`/set-role-permission`, payload)
            .then((response) => {
                resolve(response.data)
            })
            .catch((error) => {
                if (error.response.status = 422) {
                    commit('SET_ERRORS', error.response.data.errors, {root:true})
                }
            })
        })
    },
    getUserLogin({commit}) {
        return new Promise((resolve, reject) => {
            $axios.get(`/user-authenticated`)
            .then((response) => {
                commit('ASSIGN_USER_AUTH', response.data.data)
                resolve(response.data)
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