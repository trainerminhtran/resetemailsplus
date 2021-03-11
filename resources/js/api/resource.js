import request from '@/utils/request';

/**
 * Simple RESTful resource class
 */
class Resource {
  constructor(uri) {
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
  synData(query) {
    return request({
      url: '/synData/' + this.uri,
      method: 'get',
      params: query,
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
  deleteShopStock(id, resource) {
    return request({
      url: '/stock/' + id + '/delete',
      method: 'post',
      data: resource,
    });
  }
  searchExactlyProductName(resource) {
    return request({
      url: '/product/search-exactly-name',
      method: 'post',
      data: resource,
    });
  }
  mapProduct(id, resource) {
    return request({
      url: '/stock/map-product/' + id,
      method: 'post',
      data: resource,
    });
  }
  mapMultipleProduct(id, resource) {
    return request({
      url: '/stock/map-multiple-product/' + id,
      method: 'post',
      data: resource,
    });
  }
  listProductsLazada(shopId) {
    return request({
      url: 'lazada/product/' + shopId,
      method: 'get',
    });
  }
  deleteMultipleStocks(resource) {
    return request({
      url: 'stocks/delete',
      method: 'post',
      data: resource,
    });
  }
  listOrderCancel(query) {
    return request({
      url: '/order/cancel',
      method: 'get',
      params: query,
    });
  }
  listOrderDone(query) {
    return request({
      url: '/order/done',
      method: 'get',
      params: query,
    });
  }
  isStoreStock(resource) {
    return request({
      url: 'stock/is_store',
      method: 'post',
      data: resource,
    });
  }
  getStatusStoreStock() {
    return request({
      url: 'stock/status',
      method: 'get',
    });
  }
}

export { Resource as default };
