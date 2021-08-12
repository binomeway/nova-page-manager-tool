Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'nova-page-manager-tool',
      path: '/nova-page-manager-tool',
      component: require('./components/Tool'),
    },
  ])
})
