import axios from 'axios';

export const getKeranjangsData = async () => {
  try {
    const response = await axios.get('/keranjangs'); 
    return response.data;
  } catch (error) {
    console.error('Error fetching keranjangs data:', error);
    throw error;
  }
};

export const addToKeranjang = async (data) => {
  try {
    const response = await axios.post('/keranjangs', data);
    return response.data;
  } catch (error) {
    console.error('Error adding to keranjang:', error);
    throw error;
  }
};
