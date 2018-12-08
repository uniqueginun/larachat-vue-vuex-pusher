import Vue from 'vue';
import Vuex from 'vuex';
import Axios from 'axios';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        authuser: null,
        conversations: [],
        conversation: [],
        selecteduser: null,
        contacts: [],
        contactsbackup: [],
        typingusers: [],
        onlineusers: []
    },
    getters: {
        conversation(state) {
            return state.conversation;
        },
        typingUsers(state) {
            return state.typingusers;
        },
        onlineusers(state) {
            return state.onlineusers;
        },
        selecteduser(state) {
            return state.selecteduser;
        },
        authuser(state) {
            return state.authuser;
        },
        contacts(state) {
            return state.contacts;
        },
    },
    mutations: {
        filtercontacts(state, keyword) {
            if(keyword != '') {
                let newlist = state.contacts.filter(contact => {
                    return contact.name.toLowerCase().match(keyword);
                })
                state.contacts = newlist;
            } else {
                state.contacts = state.contactsbackup;
            }
        },
        setonlineusers(state, users) {
            state.onlineusers = users;
        },
        addonlineuser(state, user) {
            state.onlineusers.push(user);
        },
        removeonlineuser(state, user) {
            if(state.onlineusers.length > 0) {
                let ouser = state.contacts.find(u => {
                    return u.id == user.id;
                });
                
                let newArr = state.onlineusers.filter(u => {
                    return (u.id != ouser.id)
                });
    
                state.onlineusers = newArr; 
            }
        },
        setauthuser(state, user) {
            state.authuser = user;
        },
        setconversations(state, conversations) {
            state.conversations = conversations;
        },
        setcontacts(state, contacts) {
            state.contacts = contacts;
            state.contactsbackup = contacts;
        },
        setselecteduser(state, selecteduser) {
            state.selecteduser = selecteduser;
            state.contacts.forEach(function(obj) {
                if (obj.id == selecteduser.id) {
                    obj.unread_count = 0;
                }
            });
        },
        setconversation(state, selecteduser) {
            let conv = state.conversations.filter(conversation => {
                return (conversation.from == selecteduser.id || conversation.to == selecteduser.id)
            });
            state.conversation = conv;
        },
        updateconversation(state, message) {
            state.conversation.push(message);
        },
        handlenewmessage(state, message) {
            if(!state.selecteduser) {
                state.conversations.push(message);
            }
            else if(message.from == state.selecteduser.id) {
                state.conversation.push(message)
            } 

            state.contacts.forEach(function(obj) {
                if (obj.id == message.from) {
                    if(state.selecteduser) {
                        if(state.selecteduser.id != message.from) {
                            obj.unread_count += 1;
                        }
                    } else {
                        obj.unread_count += 1;
                    }
                }
            });

        },
        settypinguser(state, usertype) { 
            let tuser = state.contacts.find(u => {
                return u.id == usertype.user;
            });
            let existuser = state.typingusers.find(us => {
                return us.id == usertype.user;
            });
            if(usertype.type == 1) {
                if(!existuser) state.typingusers.push(tuser);
            } else {
                let newArr = state.typingusers.filter(u => {
                    return (u.id != tuser.id)
                });
                state.typingusers = newArr;
            } 
        }
    },
    actions: {
        getcontacts(context) {
            Axios.get('/contacts').then(response => {
                context.commit('setcontacts', response.data);
            })
        },
        sendnewmessage(context, text) {
            if(context.state.authuser && context.state.selecteduser) {
                let message = {
                    from: context.state.authuser.id,
                    to: context.state.selecteduser.id,
                    body: text
                }
                Axios.post('/message/new', message).then(response => {
                    context.commit('updateconversation', response.data);
                });
            }
        },
        unreadmessages(context, contact) {
            Axios.post(`/contact/${contact.id}/unread`).then(response => {
                
            });
        }
    }
});