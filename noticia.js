// Obtenha o ID da notícia da URL
const params = new URLSearchParams(window.location.search);
const noticiaId = params.get('id');

// Dados das notícias
const noticias = {
    1: {
        title: "Premiação dos Alunos no Projeto 'Nós Lemos'",
        date: "04/04/2023",
        img: "Imagem/noticia1.jpeg",
        text: `No dia 4 de abril de 2023, os alunos participantes do projeto "Nós Lemos",
        organizado pela coordenadora da nossa biblioteca, foram premiados por sua dedicação
        e entusiasmo pela leitura. Este projeto tem como objetivo incentivar os alunos a ler
        livros de vários gêneros, com foco em desenvolver o hábito da leitura e a interpretação
        crítica dos textos.

        Durante a cerimônia, alunos de diversas turmas compartilharam suas experiências e
        recomendaram livros para seus colegas. O evento foi um grande sucesso, fortalecendo
        o espírito de comunidade na nossa escola e promovendo o amor pelos livros.`


    },
    2: {
        title: "Missa em Homenagem às Mães",
        date: "26/05/2023",
        img: "Imagem/noticia2.jpeg",
        text: `No dia 26 de maio de 2023, foi realizada uma missa em homenagem a todas as mães da
        nossa comunidade escolar. A celebração contou com a presença de alunos, professores e
        familiares, que prestaram suas homenagens em um ambiente de gratidão e respeito.

        As mães foram lembradas por seu papel fundamental na vida dos alunos e no apoio
        contínuo à educação. O evento foi encerrado com uma série de apresentações musicais
        e depoimentos emocionantes dos alunos.`
    },

    3: {

    },

    4: {
        title: "Bloco de Carnaval ETE José Joaquim 2023",
        date: "16/02/2023",
        img: "Imagem/noticia4.jpeg",
        text: `No dia 16 de fevereiro de 2023, aconteceu o Bloco de Carnaval ETE José Joaquim 2023, 
                trazendo alegria e animação para a comunidade escolar! O evento reuniu alunos, professores 
                e familiares em uma grande celebração de música e dança.

                Os participantes se fantasiaram e curtiram uma programação repleta de ritmos animados, 
                com marchinhas e músicas de carnaval que contagiavam a todos. Além da diversão, o bloco 
                também promoveu a união e a criatividade, destacando o talento dos alunos em diversas apresentações.`

    },

    5: {
        title: "Feira de Troca de Mudas de Plantas Verde Viva 2024",
        date: "11/10/2024",
        img: "Imagem/noticia5.jpeg",
        text: `No dia 11 de outubro de 2024, aconteceu a Feira de Troca de Mudas de Plantas Verde Viva, edição 2024! 
                Organizada pela Professora Márcia e alguns alunos da ETE, a feira foi um sucesso e trouxe juntos amantes da 
                jardinagem em um ambiente cheio de energia positiva.

              Os participantes trouxeram mudas variadas, desde suculentas e ervas aromáticas até flores nativas, e 
              todos puderam trocar e conhecer novas espécies. Além disso, tivemos workshops divertidos sobre cultivo
            e dicas de cuidados com as plantas, tudo isso com a ajuda de especialistas apaixonados.`
    }



    // Adicione mais notícias conforme necessário
};
// Carregar os dados da notícia selecionada
const noticia = noticias[noticiaId];
if (noticia) {
    document.getElementById('noticia-title').textContent = noticia.title;
    document.getElementById('noticia-date').textContent = `Publicado em: ${noticia.date}`;
    document.getElementById('noticia-img').src = noticia.img;
    document.getElementById('noticia-text').textContent = noticia.text;
} else {
    document.getElementById('noticia-title').textContent = "Notícia não encontrada";
    document.getElementById('noticia-text').textContent = "Desculpe, a notícia que você está procurando não existe.";
}
