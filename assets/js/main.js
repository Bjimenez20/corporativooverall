function setLanguage(lang) {
    fetch(`lang/${lang}.json`)
      .then(response => response.json())
      .then(translations => {
        document.querySelectorAll('[data-i18n]').forEach(element => {
          const key = element.getAttribute('data-i18n');
          const translatedText = getNestedValue(translations, key);
          if (translatedText) {
            element.textContent = translatedText;
          }
        });
  
        // Guardar selección en localStorage
        localStorage.setItem('language', lang);
      });
  }
  
  function getNestedValue(obj, path) {
    return path.split('.').reduce((acc, part) => acc && acc[part], obj);
  }
  
  document.addEventListener('DOMContentLoaded', () => {
    const lang = localStorage.getItem('language') || 'es';
    setLanguage(lang);
  });  