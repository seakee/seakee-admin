import axios from 'axios'
import store from '@/store'
import { Message } from 'element-ui'

const http = axios.create({
    baseURL: 'http://www.skadmin.com/admin',
    timeout: 5000
});

// request拦截器
http.interceptors.request.use(config => {
    const token = store.getters.token;

    if (token){
        config.headers.Authorization = token
    }

    return config
}, error => {
    Promise.reject(error)
});

//response拦截器
http.interceptors.response.use((response) => {
    // 判断一下响应中是否有 token，如果有就直接使用此 token 替换掉本地的 token。你可以根据你的业务需求自己编写更新 token 的逻辑
    const token = response.headers.authorization;
    if (token) {
        // 如果 header 中存在 token，那么触发 refreshToken 方法，替换本地的 token
        store.dispatch('refreshToken', token);
    }
    return response
}, (error) => {
    switch (error.response.status) {

        // 如果响应中的 http code 为 401，那么则此用户可能 token 失效了之类的，我会触发 logout 方法，清除本地的数据并将用户重定向至登录页面
        case 401:
            Message({message: '登录已失效，请重新登录', type:'error', center: true});
            return store.dispatch('logout');
        // 如果响应中的 http code 为 400，那么就弹出一条错误提示给用户
        case 400:
        case 404:
        case 500:
            return Message({message: error.response.data.msg,type:'error', center: true});
    }
    return Promise.reject(error);
});

//封装get请求
export function get(url, params = {}) {
    params.t = new Date().getTime(); //get方法加一个时间参数,解决ie下可能缓存问题.
    return http({
        url    : url,
        method : 'get',
        headers: {},
        params
    })
}

//封装post请求
export function post(url, data = {}) {
    //默认配置
    const sendObject = {
        url    : url,
        method : 'post',
        headers: {
            'Content-Type': 'application/json;charset=UTF-8'
        },
        data   : data
    };
    sendObject.data  = JSON.stringify(data);
    return http(sendObject)
}

//封装put请求
export function put(url, data = {}) {
    return http({
        url    : url,
        method : 'put',
        headers: {
            'Content-Type': 'application/json;charset=UTF-8'
        },
        data   : JSON.stringify(data)
    })
}

//封装delete请求
export function deletes(url) {
    return http({
        url    : url,
        method : 'delete',
        headers: {}
    })
}

export default http