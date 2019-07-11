import {get,post,put,deletes} from "@/utils/http";

export function getList() {
    return get('/menus');
}

export function getInfo(id) {
    return get('/menus/' + id);
}

export function create(data) {
    return post('/menus/', data)
}

export function update(id, data) {
    return put('/menus/' + id, data)
}

export function deleteMenu(id) {
    return deletes('/menus/' + id);
}