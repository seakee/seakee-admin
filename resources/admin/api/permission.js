import {get,post,put,deletes} from "@/utils/http";

export function getList(params) {
    return get('/permissions', params);
}

export function getInfo(id) {
    return get('/permissions/' + id);
}

export function create(data) {
    return post('/permissions/', data)
}

export function update(id, data) {
    return put('/permissions/' + id, data)
}

export function deletePermission(id) {
    return deletes('/permissions/' + id);
}