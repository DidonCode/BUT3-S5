class Member {

    constructor(id, email, pseudo, image, banner, isPublic) {
        this.id = id.toString();
        this.email = email;
        this.pseudo = pseudo;
        this.image = image;
        this.banner = banner;
        this.isPublic = isPublic;
    }

    isValid(){
        if(!this.id			|| typeof this.id !== "string") return false;
        if(!this.email    	|| typeof this.email !== "string") return false;
        if(!this.pseudo    	|| typeof this.pseudo !== "string") return false;
        if(!this.image     	|| typeof this.image !== "string") return false;
        if(!this.banner    	|| typeof this.banner !== "string") return false;
        if((this.isPublic != 0 && this.isPublic != 1)  	|| typeof this.isPublic !== "number") return false;

        return true;
    }

    static toClass(data){
        return new Member(
            data['id'],
            data['email'],
            data['pseudo'],
            data['image'],
            data['banner'],
            data['public']
        );
    }
}

module.exports = { Member };