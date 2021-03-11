import Layout from '@/layout';

const chatRoutes = {
  path: '/chat',
  component: Layout,
  redirect: '/chat/index',
  alwaysShow: true, // will always show the root menu
  meta: {
    title: 'chats',
    icon: 'admin',
    permissions: ['view menu chat'],
  },
  children: [
    {
      path: 'chat-lists',
      component: () => import('@/views/error-page/404'),
      name: 'chatList',
      meta: { title: 'chatList' },
    },
  ],
};

export default chatRoutes;
