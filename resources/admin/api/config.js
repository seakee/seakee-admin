import {put} from "@/utils/http";

export function update(data) {
    return put('/configs', data)
}
