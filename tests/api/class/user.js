class User {
	constructor(id, email, pseudo, grade, banner, isPublic, artist) {
		this.id = id.toString();
		this.email = email;
		this.pseudo = pseudo;
		this.grade = grade;
		this.banner = banner;
		this.isPublic = isPublic;
		this.artist = artist;
	}

	isValid() {
		if (!this.id || typeof this.id !== 'string') return false;
		if (!this.email || typeof this.email !== 'string') return false;
		if (!this.pseudo || typeof this.pseudo !== 'string') return false;
		if (!this.grade || typeof this.grade !== 'number') return false;
		if (!this.banner || typeof this.banner !== 'string') return false;
		if (!this.isPublic || typeof this.isPublic !== 'number') return false;
		if (!this.artist || typeof this.artist !== 'number') return false;

		return true;
	}

	static toClass(data) {
		return new User(data['id'], data['email'], data['pseudo'], data['grade'], data['banner'], data['public'], data['artist']);
	}
}

module.exports = { User };
