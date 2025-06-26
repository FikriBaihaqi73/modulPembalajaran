import React, { useState, useEffect, useRef } from 'react';
import ReactDOM from 'react-dom/client';

const Chatbot = () => {
    console.log("Chatbot component is rendering!");
    const [isOpen, setIsOpen] = useState(false);
    const [messages, setMessages] = useState([]);
    const [currentMenu, setCurrentMenu] = useState('main'); // 'main' or 'registration', 'tutorial', etc.

    const chatWindowRef = useRef(null);

    const chatbotResponses = {
        'main': {
            message: `Halo! Selamat datang di layanan bantuan. Silakan pilih opsi di bawah ini dengan mengetikkan angka:
1. Pendaftaran
2. Login Aplikasi
3. Tutorial Aplikasi
4. Lihat dan Unduh Modul
5. Ganti Password
9. Kembali ke menu utama`,
            options: {
                '1': 'registration',
                '2': 'login',
                '3': 'tutorial',
                '4': 'module_and_download',
                '5': 'password_reset',
            }
        },
        'registration': {
            message: `Untuk melakukan pendaftaran, silakan hubungi admin Pondok IT atau Mentor jurusan Anda. Tekan 9 untuk kembali ke menu utama.`,
            options: { '9': 'main' }
        },
        'login': {
            message: `Untuk masuk ke aplikasi, silakan kunjungi halaman login di URL '/login'. Masukkan username dan password Anda yang diberikan oleh admin Pondok IT atau Mentor jurusan Anda. Jika lupa password, silakan hubungi admin Pondok IT atau Mentor jurusan Anda. Tekan 9 untuk kembali ke menu utama.`,
            options: { '9': 'main' }
        },
        'tutorial': {
            message: `Kami memiliki beberapa tutorial untuk membantu Anda menggunakan aplikasi:
- Tutorial Login: Anda bisa menekan tombol 'Login' di halaman utama, lalu masukkan username dan password Anda yang diberikan oleh admin Pondok IT atau Mentor jurusan Anda.
- Tutorial Mengakses Modul: untuk mengakses modul anda bisa klik tombol 'Modul' di halaman utama, lalu pilih modul yang ingin anda akses(jika sudah login).
- Tutorial Mengunduh Materi: Pelajari cara mengunduh modul dalam format PDF atau ZIP.
- Tutorial Mengganti Password: Anda bisa melihat panduan untuk mengganti password di profil Anda.
Tekan 9 untuk kembali ke menu utama.`,
            options: { '9': 'main' }
        },
        'module_and_download': {
            message: `Untuk melihat daftar modul pertama-tama anda wajib login terlebih dahulu lalu, kunjungi halaman Modul. Di sana, Anda bisa melihat detail setiap modul. Untuk mengunduh modul:
- Modul tunggal: Buka detail modul yanh ingin diunduh, lalu cari tombol 'Unduh PDF'.
- Modul per kategori: Anda dapat mengunduh semua modul dalam suatu kategori sebagai ZIP.dengan cari filter modul di halaman modul sesuai dengan kategori yang ingin diunduh lalu klik tombol 'Unduh ZIP'.
Tekan 9 untuk kembali ke menu utama.`,
            options: { '9': 'main' }
        },
        'password_reset': {
            message: `untuk mengganti password jika anda lupa password silahkan hubungi admin pondok IT atau Mentor jurusan anda lalu jika anda sudah login silahkan klik nama anda di pojok kanan atas lalu pilih profile disitu anda bisa mengganti password dan username bahkan nama anda`,
            options: { '9': 'main' }
        },
        'invalid': {
            message: `Pilihan tidak valid. Silakan pilih angka dari opsi yang tersedia. Tekan 9 untuk kembali ke menu utama.`
        }
    };

    const handleButtonClick = () => {
        setIsOpen(!isOpen);
        if (!isOpen) { // If opening the chat
            setMessages([]); // Clear previous messages
            setTimeout(() => {
                setMessages([{ sender: 'bot', text: chatbotResponses.main.message }]);
                setCurrentMenu('main');
            }, 300); // Small delay to allow transition
        }
    };

    const handleUserMessage = (option) => {
        const optionKey = String(option);
        const currentOptions = chatbotResponses[currentMenu]?.options;

        if (currentOptions && currentOptions[optionKey]) {
            const nextMenu = currentOptions[optionKey];
            setMessages(prev => [...prev, { sender: 'user', text: `Pilihan: ${optionKey}` }]);
            setTimeout(() => {
                setMessages(prev => [...prev, { sender: 'bot', text: chatbotResponses[nextMenu].message }]);
                setCurrentMenu(nextMenu);
            }, 500);
        } else if (optionKey === '9' && currentMenu !== 'main') { // Special case for 'back'
            setMessages(prev => [...prev, { sender: 'user', text: `Pilihan: ${optionKey}` }]);
            setTimeout(() => {
                setMessages(prev => [...prev, { sender: 'bot', text: chatbotResponses.main.message }]);
                setCurrentMenu('main');
            }, 500);
        } else {
            setMessages(prev => [...prev, { sender: 'user', text: `Pilihan: ${optionKey}` }]);
            setTimeout(() => {
                setMessages(prev => [...prev, { sender: 'bot', text: chatbotResponses.invalid.message }]);
            }, 500);
        }
    };

    // Scroll to bottom of messages
    useEffect(() => {
        if (chatWindowRef.current) {
            chatWindowRef.current.scrollTop = chatWindowRef.current.scrollHeight;
        }
    }, [messages]);

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
                        <h3 className="font-semibold">Chatbot Bantuan</h3>
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
                                    {msg.text.split('\n').map((line, i) => (
                                        <p key={i}>{line}</p>
                                    ))}
                                </div>
                            </div>
                        ))}
                    </div>
                    <div className="p-4 border-t border-gray-200 bg-white">
                        <div className="grid grid-cols-3 gap-2">
                            {Object.keys(chatbotResponses[currentMenu]?.options || {}).map(option => (
                                <button
                                    key={option}
                                    onClick={() => handleUserMessage(option)}
                                    className="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-3 rounded text-sm focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50"
                                >
                                    {option === '9' ? 'Kembali' : option}
                                </button>
                            ))}
                        </div>
                    </div>
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
