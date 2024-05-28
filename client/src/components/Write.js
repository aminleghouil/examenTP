import React, { useState } from 'react';
import axios from 'axios';
import './Write.css';

const Write = () => {
    const [content, setContent] = useState('');
    const [category, setCategory] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault();
        const author_id = 1; // Placeholder for the logged-in user's ID
        axios.post('http://localhost/server/api/posts.php', { content, category, author_id })
            .then(response => {
                alert('Post created successfully!');
                console.log(response.data);
            })
            .catch(error => {
                alert('Post creation failed!');
                console.error('Error creating post:', error);
            });
    };

    return (
        <div className="write">
            <h1>Create a Post</h1>
            <form onSubmit={handleSubmit}>
                <textarea
                    placeholder="Write your post here..."
                    value={content}
                    onChange={(e) => setContent(e.target.value)}
                    required
                />
                <input
                    type="text"
                    placeholder="Category"
                    value={category}
                    onChange={(e) => setCategory(e.target.value)}
                    required
                />
                <button type="submit">Post</button>
            </form>
        </div>
    );
};

export default Write;
