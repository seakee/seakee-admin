import {post} from "../utils/http";

export function login(account, password) {
    return post('/auth/login', {
            'account' : account,
            'password': password
        }
    )
}