import {get,post,put,deletes} from "@/utils/http";

export function getList(params) {
    return get('/roles', params);
}

export function getInfo(id) {
    return get('/roles/' + id);
}

export function create(data) {
    return post('/roles/', data)
}

export function update(id, data) {
    return put('/roles/' + id, data)
}

export function deleteRole(id) {
    return deletes('/roles/' + id);
}

export function syncPermissions(id, data) {
    return put('/roles/' + id + '/permissions', data)
}

export function getPermissions(id) {
    return get('/roles/' + id + '/permissions')
}