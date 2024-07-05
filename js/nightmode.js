// nightmode.js
document.addEventListener('DOMContentLoaded', () => {
  const chk = document.getElementById('chk');
  const isDarkMode = localStorage.getItem('dark-mode') === 'true';

  // Configure o estado inicial do botão de modo noturno
  if (isDarkMode) {
    document.body.classList.add('dark');
    chk.checked = true;
  } else {
    document.body.classList.remove('dark');
    chk.checked = false;
  }

  // Adicione um evento para alternar o modo noturno
  chk.addEventListener('change', () => {
    document.body.classList.add('transition');
    document.body.classList.toggle('dark');
    const isDarkMode = document.body.classList.contains('dark');
    localStorage.setItem('dark-mode', isDarkMode);
    
    // Remover a classe de transição após a transição
    setTimeout(() => {
      document.body.classList.remove('transition');
    }, 300); // 300ms deve ser maior que a duração da transição definida no CSS
  });
});

function corbranco() {
  const isDarkMode = document.body.classList.contains('dark');
  const clipElement = document.getElementById('clip');
  
  if (clipElement) {
    clipElement.style.fill = isDarkMode ? '#ffffff' : '#000000';
  }
}
