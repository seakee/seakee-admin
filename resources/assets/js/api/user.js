import {get,post,put,deletes} from "@/utils/http";

export function getList() {
    return get('/user/index');
}

export function getInfo(id) {
    return get('/user/' + id);
}

export function create(data) {
    return post('/user/', data)
}