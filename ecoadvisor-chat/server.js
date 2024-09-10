const express = require('express');
const axios = require('axios');

const app = express();
const port = 3000;

app.use(express.json());

app.post('/chat', async (req, res) => {
    const userInput = req.body.message;

    try {
        const response = await axios.post('https://api.gemini.com/v1/chat', {
            prompt: userInput,
            max_tokens: 100,
        }, {
            headers: {
                'Authorization': `AIzaSyBmr3oGUlxzv6QZYhpvwEHrqnRfsO4QkfQ`,
                'Content-Type': 'application/json'
            }
        });

        res.json({ reply: response.data.choices[0].text });
    } catch (error) {
        console.error('Error communicating with Gemini API:', error);
        res.status(500).json({ error: 'Internal Server Error' });
    }
});

app.listen(port, () => {
    console.log(`EcoAdvisor Chat backend running at http://localhost:${port}`);
});
