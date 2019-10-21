import {post, get, put} from "@/utils/http";

export function login(account, password) {
    return post('/auth/login', {
            'account' : account,
            'password': password
        }
    );
}

export function logout() {
    return post('/auth/logout');
}

export function profile() {
    return get('/auth/profile');
}

export function updateProfile(data) {
    return put('/auth/profile', data);
}
