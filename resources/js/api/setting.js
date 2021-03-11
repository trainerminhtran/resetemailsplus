import request from '@/utils/request';
import Resource from '@/api/resource';

class Settings extends Resource {
  constructor(uri) {
    super('stocks');
    this.uri = uri;
  }
  list(query) {
    return request({
      url: '/setting',
      method: 'get',
      params: query,
    });
  }
  update(id, resource) {
    return request({
      url: '/setting/' + id,
      method: 'put',
      data: resource,
    });
  }
}

export { Settings as default };
