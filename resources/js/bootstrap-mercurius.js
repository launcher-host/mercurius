/**
 * Generic components...
 */
Vue.component('mercurius-avatar', require('./core/Avatar.vue'));
Vue.component('profile-settings', require('./core/profile-settings.js'));
Vue.component('btn-compose', require('./core/BtnCompose.vue'));


/**
 * Sidebar...
 */
Vue.component('mercurius-sidebar', require('./sidebar/Sidebar.vue'));
Vue.component('btn-sidebar-toggle', require('./sidebar/BtnSidebarToggle.vue'));


/**
 * Conversations components...
 */
Vue.component('conversations', require('./conversations/Conversations.vue'));
Vue.component('conversations-filter', require('./conversations/ConversationsFilter.vue'));


/**
 * Messages components..
 */
Vue.component('messages', require('./messages/Messages.vue'));
Vue.component('recipient', require('./messages/Recipient.vue'));
Vue.component('composer', require('./messages/Composer.vue'));
