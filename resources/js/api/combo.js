import request from '@/utils/request';
import Resource from '@/api/resource';

class Combo extends Resource {
  constructor(uri) {
    super('combo');
    this.uri = uri;
  }
  list(query) {
    return request({
      url: '/product-combo',
      method: 'get',
      params: query,
    });
  }

  get(id) {
    return request({
      url: '/product-combo/' + id,
      method: 'get',
    });
  }

  store(resource) {
    return request({
      url: '/product-combo',
      method: 'post',
      data: resource,
    });
  }
  update(id, resource) {
    return request({
      url: '/product-combo/' + id,
      method: 'put',
      data: resource,
    });
  }
  destroy(id) {
    return request({
      url: '/product-combo/' + id,
      method: 'delete',
    });
  }
  mapProduct(id, resource) {
    return request({
      url: '/combo/map-product/' + id,
      method: 'post',
      data: resource,
    });
  }
  mapMultipleProduct(id, resource) {
    return request({
      url: '/combo/map-multiple-product/' + id,
      method: 'post',
      data: resource,
    });
  }
  deleteMultipleStocks(resource) {
    return request({
      url: 'combo/delete',
      method: 'post',
      data: resource,
    });
  }
  deleteShopStock(id, resource) {
    return request({
      url: '/combo/' + id + '/delete',
      method: 'post',
      data: resource,
    });
  }
  switchStock(resource) {
    return request({
      url: '/combo/switch-stock',
      method: 'post',
      data: resource,
    });
  }
}
export { Combo as default };
