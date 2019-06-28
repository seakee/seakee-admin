import {get,post,put,deletes} from "@/utils/http";

export function getList(params) {
    return get('/users', params);
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

export function update(id, data) {
    return put('/users/' + id, data)
}

export function deleteUser(id) {
    return deletes('/users/' + id);
}

export function syncRoles(id, data) {
    return put('/users/' + id + '/roles', data)
}

export function getRoles(id) {
    return get('/users/' + id + '/roles');
}