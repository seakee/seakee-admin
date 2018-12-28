import {get,post,put,deletes} from "@/utils/http";

export function getList() {
    return get('/users/index');
}

export function getInfo(id) {
    return get('/users/' + id);
}

export function create(data) {
    return post('/users/', data)
}

export function profile() {
    return get('/users/profile');
}