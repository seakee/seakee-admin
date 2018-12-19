import {post, get} from "@/utils/http";

export function login(account, password) {
    return post('/auth/login', {
            'account' : account,
            'password': password
        }
    );
}

export function profile() {
    return get('/auth/profile');
}
}