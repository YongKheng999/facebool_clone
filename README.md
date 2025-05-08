## Facebook Clone API

### Features
1. User Authentication (Login, Register, Delete Account)
2. Post Creation (Create, Update, Delete)
3. Like Post (Like, Unlike)
4. Comment on Post (Create, Update, Delete)

### Additional Features
1. User Profile Image Upload
2. Post Image Upload
3. Post Pagination
4. Post Search

---

## users

- email varchar(255) not null  
- password varchar(255) not null  
- name varchar(255) not null  
- profile_image varchar(255) not null  
- created_at timestamp not null  
- updated_at timestamp not null  

## posts

- user_id int not null  
- caption text not null  
- image varchar(255) not null  
- created_at timestamp not null  
- updated_at timestamp not null  

## likes

- user_id int not null  
- post_id int not null  
- created_at timestamp not null  
- updated_at timestamp not null  

## comments

- user_id int not null  
- post_id int not null  
- text text not null  
- created_at timestamp not null  
- updated_at timestamp not null  
