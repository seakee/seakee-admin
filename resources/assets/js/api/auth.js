import {post, get} from "@/utils/http";

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