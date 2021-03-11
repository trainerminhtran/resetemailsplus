import request from '@/utils/request';
import Resource from '@/api/resource';

class Dashboard extends Resource {
  constructor(uri) {
    super('statistic');
    this.uri = uri;
  }
  list(query) {
    return request({
      url: '/' + this.uri,
      method: 'get',
      params: query,
    });
  }

  get(id) {
    return request({
      url: '/' + this.uri + '/' + id,
      method: 'get',
    });
  }

  store(resource) {
    return request({
      url: '/' + this.uri,
      method: 'post',
      data: resource,
    });
  }
  update(id, resource) {
    return request({
      url: '/' + this.uri + '/' + id,
      method: 'put',
      data: resource,
    });
  }
  destroy(id) {
    return request({
      url: '/' + this.uri + '/' + id,
      method: 'delete',
    });
  }
}
export { Dashboard as default };
