
import admin from '../pages/admin.vue'
import type from '../pages/type.vue'
import categories from '../pages/category.vue'
import subcategories from '../pages/subcategory.vue'
import subSubcategories from '../pages/subSubcategory.vue'
import information from '../pages/information.vue'
import addInfo from '../components/information/addInfo.vue'
import editInfo from '../components/information/editInfo.vue'
import profile from '../pages/profile.vue'
import importexport from '../pages/importexport.vue'
import backup from '../pages/backup.vue'



const routes = [
    {path : '/admin', component: admin, name: 'admin'},
    {path : '/type', component: type, name: 'type'},
    {path : '/categories', component: categories, name: 'categories'},
    {path : '/subcategories', component: subcategories, name: 'subcategories'},
    {path : '/sub-subcategories', component: subSubcategories, name: 'sub-subcategories'},
    {path : '/information', component: information, name: 'information'},
    {path : '/information/add', component: addInfo, name: 'information'},
    {path : '/information/edit/:id', component: editInfo, name: 'information'},
    {path : '/profile', component: profile, name: 'profile'},
    {path : '/backup', component: backup, name: 'backup'},
    {path : '/import-export', component: importexport, name: 'importexport'},

]

export default routes
