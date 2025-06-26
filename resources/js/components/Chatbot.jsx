import React, { useState, useEffect, useRef } from 'react';
import ReactDOM from 'react-dom/client';

const Chatbot = () => {
    const [isOpen, setIsOpen] = useState(false);
    const [messages, setMessages] = useState([]);
    const [inputMessage, setInputMessage] = useState(''); // State baru untuk input teks pengguna
    const [isLoading, setIsLoading] = useState(false); // State untuk menunjukkan proses loading

    const chatWindowRef = useRef(null);

    const initialBotMessage = `Halo! 👋 Saya adalah AI Chatbot Bantuan Aplikasi Pembelajaran Santri Pondok IT. Apa yang bisa saya bantu hari ini? Anda bisa bertanya apapun tentang aplikasi ini.`;

    // Fungsi untuk mengirim pesan ke Puter.js AI
    const sendMessageToPuterAI = async (message) => {
        setIsLoading(true);
        setMessages(prev => [...prev, { sender: 'user', text: message }]);

        try {
            // Kirim string langsung, bukan objek
            const response = await puter.ai.chat(message);
            setMessages(prev => [...prev, { sender: 'bot', text: response.message.content }]);
        } catch (error) {
            console.error("Error communicating with Puter.js AI:", error);
            setMessages(prev => [...prev, { sender: 'bot', text: "Maaf, saya mengalami masalah saat berkomunikasi dengan AI. Silakan coba lagi nanti." }]);
        } finally {
            setIsLoading(false);
        }
    };

    const handleButtonClick = () => {
        setIsOpen(!isOpen);
        if (!isOpen) { // If opening the chat
            setMessages([]); // Clear previous messages
            setTimeout(() => {
                setMessages([{ sender: 'bot', text: initialBotMessage }]);
            }, 300); // Small delay to allow transition
        }
    };

    const handleInputChange = (e) => {
        setInputMessage(e.target.value);
    };

    const handleSendMessage = (e) => {
        e.preventDefault();
        if (inputMessage.trim() === '') return;

        sendMessageToPuterAI(inputMessage);
        setInputMessage(''); // Bersihkan input setelah kirim
    };

    // Scroll to bottom of messages
    useEffect(() => {
        if (chatWindowRef.current) {
            chatWindowRef.current.scrollTop = chatWindowRef.current.scrollHeight;
        }
    }, [messages]);

    // Tambahkan pesan awal saat chat dibuka
    useEffect(() => {
        if (isOpen && messages.length === 0) {
            setMessages([{ sender: 'bot', text: initialBotMessage }]);
        }
    }, [isOpen, messages.length]);


    return (
        <div className="fixed bottom-4 right-4 z-50">
            {/* Floating Button */}
            <button
                onClick={handleButtonClick}
                className="bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-full shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-300"
            >
                <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5zm11-5H10" />
                </svg>
            </button>

            {/* Chat Window */}
            {isOpen && (
                <div className="absolute bottom-16 right-0 w-80 md:w-96 h-96 bg-white border border-gray-300 rounded-lg shadow-xl flex flex-col transition-transform transform origin-bottom-right duration-300 ease-out z-50">
                    <div className="p-4 bg-blue-600 text-white rounded-t-lg flex justify-between items-center">
                        <h3 className="font-semibold">AI Chatbot</h3>
                        <button onClick={handleButtonClick} className="text-white hover:text-gray-200 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fillRule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clipRule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    <div ref={chatWindowRef} className="flex-1 p-4 overflow-y-auto bg-gray-50">
                        {messages.map((msg, index) => (
                            <div key={index} className={`mb-2 ${msg.sender === 'bot' ? 'text-left' : 'text-right'}`}>
                                <div className={`inline-block p-2 rounded-lg ${msg.sender === 'bot' ? 'bg-gray-200 text-gray-800' : 'bg-blue-500 text-white'}`}>
                                    {typeof msg.text === 'string' && msg.text.length > 0
                                        ? msg.text.split('\n').map((line, i) => <p key={i}>{line}</p>)
                                        : <p>(Pesan tidak tersedia)</p>
                                    }
                                </div>
                            </div>
                        ))}
                        {isLoading && (
                            <div className="mb-2 text-left">
                                <div className="inline-block p-2 rounded-lg bg-gray-200 text-gray-800">
                                    Mengetik...
                                </div>
                            </div>
                        )}
                    </div>
                    <form onSubmit={handleSendMessage} className="p-4 border-t border-gray-200 bg-white flex">
                        <input
                            type="text"
                            value={inputMessage}
                            onChange={handleInputChange}
                            placeholder="Ketik pesan Anda..."
                            className="flex-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                            disabled={isLoading}
                        />
                        <button
                            type="submit"
                            className="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            disabled={isLoading}
                        >
                            Kirim
                        </button>
                    </form>
                </div>
            )}
        </div>
    );
};

document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('chatbot-root');
    if (container) {
        const root = ReactDOM.createRoot(container);
        root.render(
            <React.StrictMode>
                <Chatbot />
            </React.StrictMode>
        );
    }
});

export default Chatbot;
