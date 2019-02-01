let user = window.App.user;

module.exports = {
    owns(model, prop = 'user_id') {
        return model[prop] === user.id;
    },

    can(permission) {
        let userPermissions = window.App.userPermissions;

        if (userPermissions.includes(permission))
            return true;
        else
            return false;
    },

    isAdmin() {
        if (window.App.isAdmin)
            return true;
        else
            return false;
    }
};