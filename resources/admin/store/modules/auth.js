import axios                          from "axios";
import {login, logout}                from "@/api/auth";
import {profile}                      from "@/api/user";
import {getData, setData, removeData} from "@/utils/localStorage";
import router from '@/router'

let auth = {
    state    : {
        token  : getData('token'),
        profile: null
    },
    mutations: {
        // 用户登录成功，存储 token 并设置 header 头
        setToken(state, token) {
            state.token = token;
        },
        // 用户刷新 token 成功，使用新的 token 替换掉本地的token
        refreshToken(state, token) {
            state.token                                    = token;
            axios.defaults.headers.common['Authorization'] = state.token;
        },
        // 登录成功后拉取用户的信息存储到本地
        profile(state, data) {
            state.profile = data;

        },
        // 用户登出，清除本地数据
        logout(state) {
            state.token   = null;
            state.profile = null;
        }
    },
    actions  : {
        // 登录成功后保存用户信息
        login({commit}, loginInfo) {
            return new Promise(function (resolve, reject) {
                login(
                    loginInfo.account.trim(),
                    loginInfo.password
                ).then(response => {
                    if (response.status === 201) {
                        let data = response.data.data;
                        commit('setToken', data.token);
                        setData('token', data.token);
                        resolve()
                    } else {
                        reject();
                    }
                }).catch(error => {
                    reject(error)
                });
            })
        },
        // 登录成功后使用 token 拉取用户的信息
        profile({commit}) {
            return new Promise(function (resolve, reject) {
                profile().then(response => {
                    if (response.status === 200) {
                        let data = response.data.data;
                        commit('profile', data);
                        resolve()
                    } else {
                        reject();
                    }
                }).catch(error => {
                    reject(error)
                });
            });
        },
        // 用户登出，清除本地数据并重定向至登录页面
        logout({commit}) {
            return new Promise(function (resolve, reject) {
                logout().then(response => {
                    if (response.status === 200) {
                        commit('logout', '');
                        removeData('token');
                        router.push({path: '/login'});
                        resolve()
                    } else {
                        reject();
                    }
                }).catch(error => {
                    reject(error)
                });
            })
        },
        // 将刷新的 token 保存至本地
        refreshToken({commit}, token) {
            return new Promise(function (resolve, reject) {
                commit('refreshToken', token);
                setData('token', token);
            })
        },
    }
};

export default auth
