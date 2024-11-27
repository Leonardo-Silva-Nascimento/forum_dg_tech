<template>
    <div>
        <h1>Forum de perguntas e respostas da dg_tech</h1>

        <!-- Seção de pesquisa -->
        <div v-if="$page.props.user?.name != null"  class="search-section mb-4">
            <input   v-model="searchQuery" type="text" placeholder="Pesquisar Comentários" class="search-input" />
            <button   @click="searchComments" class="search-button">Pesquisar</button>
        </div>

        <div v-if="$page.props.user?.name == null"  class="search-section mb-4">
            <h2>Para responder ou postar comentarios faça o Cadastro na lateral e realize login</h2>
        </div>

        <!-- Botão de Adicionar Comentário -->
        <div v-if="$page.props.user?.name != null" class="add-comment-section mb-4">
            <button @click="toggleAddCommentForm" class="add-comment-button">
                Adicionar Comentário
            </button>
            <div v-if="showAddCommentForm" class="add-comment-form">
                <textarea   v-model="newComment" placeholder="Escreva seu comentário aqui..."></textarea>
                <button   @click="addComment" class="submit-comment-button">Enviar</button>
            </div>
        </div>

        <!-- Lista de Comentários -->
        <div v-for="comment in filteredComments" :key="comment.id" class="comment">
            <p><strong>Usuario:</strong> {{ comment.username }}</p>
            <p><strong>Comentário:</strong> {{ comment.texto }}</p>
            <p><small>{{ formatTime(comment.hora) }}</small></p>

            <!-- Botão para adicionar resposta -->
            <button v-if="$page.props.user?.name != null"  @click="toggleReplyForm(comment.id)" class="reply-button">Responder</button>

            <!-- Respostas -->
            <div v-if="comment.respostas.length > 0" class="replies">
                <h4>Respostas:</h4>
                <div v-for="reply in comment.respostas" :key="reply.id" class="reply">
                    <p><strong>Usuario:</strong> {{ comment.username }}</p>
                    <p>{{ reply.texto }}</p>
                    <p><small>{{ formatTime(reply.hora) }}</small></p>
                </div>
            </div>

            <!-- Formulário para adicionar resposta -->
            <div v-if="replyForms[comment.id]" class="reply-form">
                <textarea v-model="newReply[comment.id]" placeholder="Escreva sua resposta..."></textarea>
                <button @click="addReply(comment.id)" class="submit-reply-button">Enviar Resposta</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'; // Importando o Axios

export default {
    props: {
        comments: Array,
    },
    data() {
        return {
            searchQuery: '', // Variável para o campo de pesquisa
            showAddCommentForm: false, // Controle para mostrar o formulário de adicionar comentário
            newComment: '', // Variável para o novo comentário
            newReply: {}, // Objeto para armazenar respostas de cada comentário
            replyForms: {}, // Controle para mostrar o formulário de resposta
        };
    },
    computed: {
        filteredComments() {
            // Filtra os comentários com base na pesquisa
            if (this.searchQuery) {
                return this.comments.filter((comment) =>
                    comment.texto.toLowerCase().includes(this.searchQuery.toLowerCase())
                );
            }
            return this.comments;
        },
    },
    methods: {
        formatTime(time) {
            return new Date(time).toLocaleString();
        },
        searchComments() {
            console.log("Pesquisando por:", this.searchQuery);
        },
        toggleAddCommentForm() {
            // Alterna a exibição do formulário para adicionar comentário
            this.showAddCommentForm = !this.showAddCommentForm;
        },
        async addComment() {
            // Adicionar comentário (enviando ao backend)
            if (this.newComment.trim() !== '') {
                try {
                    const response = await axios.post('/api/comentarios', {
                        texto: this.newComment,
                    });
                    console.log('Comentário adicionado com sucesso:', response.data);
                    this.newComment = ''; // Limpar campo após envio
                    this.showAddCommentForm = false; // Fechar o formulário
                    window.location.reload();
                } catch (error) {
                    console.error('Erro ao adicionar comentário:', error);
                    alert("Ocorreu um erro ao adicionar o comentário.");
                }
            } else {
                alert("Comentário não pode ser vazio");
            }
        },
        toggleReplyForm(commentId) {
            // Alterna a exibição do formulário de resposta
            this.replyForms[commentId] = !this.replyForms[commentId];
        },
        async addReply(commentId) {
            // Adicionar resposta a um comentário específico (enviando ao backend)
            const reply = this.newReply[commentId];
            if (reply && reply.trim() !== '') {
                try {
                    const response = await axios.post('/api/respostas', {
                        comentario_pai: commentId,
                        texto: reply,
                    });
                    console.log(`Resposta para o comentário ${commentId} adicionada com sucesso:`, response.data);
                    this.newReply[commentId] = ''; // Limpar campo após envio
                    this.replyForms[commentId] = false; // Fechar o formulário de resposta
                    window.location.reload();
                } catch (error) {
                    console.error('Erro ao adicionar resposta:', error);
                    alert("Ocorreu um erro ao adicionar a resposta.");
                }
            } else {
                alert("Resposta não pode ser vazia");
            }
        },
    },
};
</script>

<style scoped>
.comment {
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 10px;
}

.replies {
    margin-top: 10px;
    padding-left: 20px;
    border-left: 2px solid #ddd;
}

.reply {
    margin-bottom: 10px;
}

.search-section {
    margin-bottom: 20px;
}

.search-input {
    padding: 8px;
    width: 200px;
    margin-right: 10px;
}

.search-button {
    padding: 8px;
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
}

.add-comment-button {
    background-color: #28a745;
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
}

.add-comment-form textarea {
    width: 100%;
    height: 100px;
    margin-bottom: 10px;
    padding: 10px;
}

.submit-comment-button {
    padding: 8px;
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
}

.reply-button {
    margin-top: 10px;
    padding: 8px;
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
}

.reply-form {
    margin-top: 10px;
}

.reply-form textarea {
    width: 100%;
    height: 50px;
    margin-bottom: 10px;
    padding: 10px;
}

.submit-reply-button {
    padding: 8px;
    background-color: #28a745;
    color: white;
    border: none;
    cursor: pointer;
}
</style>
