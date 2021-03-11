import Layout from '@/layout';

const settingRoutes = {
  path: '/setting',
  component: Layout,
  redirect: '/setting',
  alwaysShow: true, // will always show the root menu
  meta: {
    title: 'setting',
    icon: 'admin',
    permissions: ['view menu store'],
  },
  children: [
    {
      path: 'general',
      component: () => import('@/views/settings/Setting'),
      name: 'settingStock',
      meta: { title: 'settingStock' },
    },
    {
      path: 'order',
      component: () => import('@/views/settings/Order'),
      name: 'settingOrder',
      meta: { title: 'settingOrder' },
    },
  ],
};

export default settingRoutes;
