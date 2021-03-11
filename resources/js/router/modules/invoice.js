import Layout from '@/layout';

const invoiceRoutes = {
  path: '/invoice',
  component: Layout,
  redirect: '/invoice/index',
  alwaysShow: true,
  meta: {
    title: 'invoices',
    icon: 'admin',
    permissions: ['view menu order'],
  },
  children: [
    {
      path: 'invoice-list',
      component: () => import('@/views/invoices/List'),
      name: 'invoiceList',
      meta: { title: 'invoiceList' },
    },
    {
      path: 'invoice-create',
      component: () => import('@/views/invoices/Create'),
      name: 'invoiceCreate',
      meta: { title: 'invoiceCreate' },
      hidden: true,
    },
    {
      path: 'invoice-detail/:id',
      component: () => import('@/views/invoices/Detail'),
      name: 'invoiceDetail',
      meta: { title: 'invoiceDetail' },
      hidden: true,
    },
  ],
};

export default invoiceRoutes;
